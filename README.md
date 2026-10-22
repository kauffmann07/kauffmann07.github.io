# Projeção 2026 · 2º turno

Página única com uma simulação independente do segundo turno das eleições de 2026, comparando Flávio Bolsonaro e Lula a partir de hipóteses de transferência de votos, abstenção e retorno de abstencionistas.

**Não é pesquisa eleitoral, não é apuração oficial e não representa intenção de voto.**

## Conteúdo

- Placar projetado e margem
- Transferências dos dez candidatos do 1º turno que não disputam o 2º turno
- Novas abstenções e retorno de abstencionistas
- Série histórica de 2018, 2022 e 2026
- Metodologia, premissas e limitações

## Interface

- Menu de seções no desktop e menu acessível no celular
- Guia “Como ler esta projeção”, com glossário e resumo das premissas
- Navegação por teclado: `Esc` fecha menus e ajuda; `?` abre a ajuda
- Atalhos para copiar o link, imprimir/salvar em PDF e voltar ao topo
- Estado ativo da seção, foco visível e retorno de foco após fechar diálogos

## Stack

HTML, CSS e JavaScript puro, sem etapa de build. Tipografia via Google Fonts (Sora, Inter e JetBrains Mono). Gráficos em CSS e SVG.

## Rodar localmente

```bash
python -m http.server 8787
```

Depois abra `http://127.0.0.1:8787/`.

## Publicação

O site é publicado via GitHub Pages em <https://kauffmann07.github.io/>.

## Dados

Os resultados históricos de 2018 e 2022 são do Tribunal Superior Eleitoral (TSE). Os números da projeção de 2026 foram informados pelo autor da página e organizados como um exercício de cenário.
