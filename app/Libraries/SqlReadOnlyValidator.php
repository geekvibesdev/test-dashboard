<?php

namespace App\Libraries;

/**
 * Valida que un SQL sea exclusivamente de lectura (SELECT) y opcionalmente
 * que use solo tablas permitidas. No ejecuta nada.
 */
class SqlReadOnlyValidator
{
    /** Palabras prohibidas (escritura o peligrosas). Minusculas para comparar. */
    private const BLACKLIST_KEYWORDS = [
        'insert', 'update', 'delete', 'drop', 'create', 'alter', 'truncate',
        'replace', 'grant', 'revoke', 'exec', 'execute', 'call', 'lock', 'unlock',
        'load', 'outfile', 'dumpfile', 'procedure', 'into', 'handler',
        'prepare', 'execute', 'deallocate', 'get_diagnostics',
    ];

    /** Tablas permitidas para el agente de reporte (solo SELECT sobre estas). */
    private const DEFAULT_ALLOWED_TABLES = [
        'ordenes',
        'ordenes_productos',
        'ordenes_facturacion',
        'ordenes_costo_real',
        'paqueterias',
        'promociones',
    ];

    private array $allowedTables;
    private int $defaultLimit;
    private bool $injectLimitIfMissing;

    public function __construct(
        ?array $allowedTables = null,
        int $defaultLimit = 500,
        bool $injectLimitIfMissing = true
    ) {
        $this->allowedTables         = $allowedTables ?? self::DEFAULT_ALLOWED_TABLES;
        $this->defaultLimit          = $defaultLimit;
        $this->injectLimitIfMissing  = $injectLimitIfMissing;
    }

    /**
     * Valida el SQL y opcionalmente lo normaliza (una sentencia, LIMIT).
     *
     * @return array{valid: bool, sql: string|null, error: string|null}
     */
    public function validate(string $sql): array
    {
        $sql = $this->normalize($sql);

        if ($sql === '') {
            return ['valid' => false, 'sql' => null, 'error' => 'SQL vacio'];
        }

        // Una sola sentencia (no permitir ; en el medio)
        $parts = array_map('trim', explode(';', $sql));
        $parts = array_filter($parts, static fn ($p) => $p !== '');
        if (count($parts) > 1) {
            return ['valid' => false, 'sql' => null, 'error' => 'Solo se permite una sentencia SQL'];
        }
        $sql = trim($parts[0] ?? '');

        // Debe empezar por SELECT
        $upper = strtoupper(ltrim($sql));
        if (strpos($upper, 'SELECT') !== 0) {
            return ['valid' => false, 'sql' => null, 'error' => 'Solo se permiten consultas SELECT'];
        }

        // Blacklist de palabras (evitar SELECT ... INTO, etc.)
        $upperForBlacklist = strtoupper($sql);
        foreach (self::BLACKLIST_KEYWORDS as $keyword) {
            $kw = strtoupper($keyword);
            if (preg_match('/\b' . preg_quote($kw, '/') . '\b/i', $sql)) {
                return ['valid' => false, 'sql' => null, 'error' => "Palabra no permitida en consulta de solo lectura: {$keyword}"];
            }
        }

        // Whitelist de tablas
        $tables = $this->extractTables($sql);
        foreach ($tables as $table) {
            if (! in_array($table, $this->allowedTables, true)) {
                return ['valid' => false, 'sql' => null, 'error' => "Tabla no permitida: {$table}"];
            }
        }

        // Inyectar LIMIT si no tiene
        if ($this->injectLimitIfMissing && ! preg_match('/\bLIMIT\s+\d+/i', $sql)) {
            $sql = rtrim($sql, " \t\n\r;") . ' LIMIT ' . $this->defaultLimit;
        }

        return ['valid' => true, 'sql' => $sql, 'error' => null];
    }

    private function normalize(string $sql): string
    {
        $sql = trim($sql);
        $sql = preg_replace('/--[^\n]*/', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
        return trim($sql);
    }

    private function extractTables(string $sql): array
    {
        $tables = [];
        if (preg_match_all('/(?:FROM|JOIN)\s+`?(\w+)`?(?:\.`?(\w+)`?)?/i', $sql, $m, PREG_SET_ORDER)) {
            foreach ($m as $match) {
                $table = isset($match[2]) && $match[2] !== '' ? $match[2] : $match[1];
                $table = strtolower($table);
                if ($table !== 'as') {
                    $tables[] = $table;
                }
            }
        }
        return array_unique($tables);
    }
}
