#!/usr/bin/env bash
# Expone Ollama local (puerto 11434) con Cloudflare Tunnel.
# Uso: ./scripts/tunnel-ollama.sh
# Requiere: Ollama corriendo en local, cloudflared instalado (brew install cloudflared).
# La app en CapRover (VPS) usara la URL que muestre este script como ollama_base_url.

set -e
OLLAMA_PORT="${OLLAMA_PORT:-11434}"

if ! command -v cloudflared &>/dev/null; then
  echo "cloudflared no esta instalado. Instalalo con: brew install cloudflared"
  exit 1
fi

echo "Exponiendo http://localhost:${OLLAMA_PORT} con Cloudflare Tunnel..."
echo "Cuando veas la URL (ej. https://xxx.trycloudflare.com), configurala en CapRover:"
echo "  App -> App Configs -> Environment Variables -> ollama_base_url = <esa URL>"
echo ""
cloudflared tunnel --url "http://localhost:${OLLAMA_PORT}"
