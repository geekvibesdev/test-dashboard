# Agente de reporte (Ollama) + Cloudflare + CapRover

## Arquitectura

- **Tu maquina local**: Ollama corre en `http://localhost:11434`.
- **Cloudflare Tunnel**: Expone ese puerto con una URL publica (ej. `https://xxx.trycloudflare.com`).
- **VPS (CapRover)**: La app del dashboard corre ahi y llama a Ollama usando la URL del tunnel.

La app en CapRover **no** tiene Ollama instalado; se conecta a **tu** Ollama a traves de Cloudflare.

## 1. En tu maquina (donde corre Ollama)

1. Instala y levanta Ollama; asegurate de tener un modelo (ej. `qwen3-coder-next`):
   ```bash
   ollama run qwen3-coder-next
   ```
2. Instala cloudflared si no lo tienes:
   ```bash
   brew install cloudflared
   ```
3. Ejecuta el tunnel:
   ```bash
   ./scripts/tunnel-ollama.sh
   ```
4. Copia la URL que muestra (ej. `https://abc123.trycloudflare.com`). Esa URL es la que usara la app en el VPS.

## 2. En CapRover (VPS)

1. En la app del dashboard: **App Configs** -> **Environment Variables**.
2. Agrega o edita:
   - `ollama_base_url` = URL del tunnel (ej. `https://abc123.trycloudflare.com`) **sin** barra final.
   - `ollama_model` = modelo que usas (ej. `qwen3-coder-next`).
   - `ollama_timeout` = opcional, ej. `60`.
3. Redeploy o reinicia la app para que tome las variables.

## 3. Migracion de base de datos

Las migraciones se ejecutan **solas al arrancar el contenedor** (entrypoint del Docker). No hace falta SSH ni CLI en CapRover: cada vez que la app hace deploy o reinicia, corre `php spark migrate --all` y luego arranca Apache. La tabla `agente_reportes_log` se crea en ese paso.

## 4. Verificar

- Con el tunnel activo, desde el navegador o desde el VPS: `curl https://<tu-url-trycloudflare>/api/tags` deberia listar modelos de Ollama.
- En la app (como admin): **Informes** -> **Agente de reporte**. Haz una pregunta en lenguaje natural; si Ollama y el tunnel estan bien, deberia responder.

## Notas

- El tunnel **trycloudflare** es temporal; si reinicias cloudflared te dan otra URL y tenes que actualizar `ollama_base_url` en CapRover.
- Para una URL fija: Cloudflare Tunnels con nombre (cuenta Cloudflare + `cloudflared tunnel create`), y apuntar `ollama_base_url` a ese hostname.
