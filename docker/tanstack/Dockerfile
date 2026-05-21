# =========================================
# Stage 1 — Dépendances
# =========================================
FROM node:22-alpine AS deps
WORKDIR /app
COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* ./
RUN \
  if [ -f pnpm-lock.yaml ]; then corepack enable pnpm && pnpm i --frozen-lockfile; \
  elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
  else npm ci; fi

# =========================================
# Stage 2 — Dev (hot-reload via volume)
# =========================================
FROM deps AS dev
ENV NODE_ENV=development
EXPOSE 3000
CMD \
  if [ -f pnpm-lock.yaml ]; then pnpm dev --host 0.0.0.0; \
  elif [ -f yarn.lock ]; then yarn dev --host 0.0.0.0; \
  else npm run dev -- --host 0.0.0.0; fi

# =========================================
# Stage 3 — Build
# =========================================
FROM deps AS builder
COPY . .
RUN \
  if [ -f pnpm-lock.yaml ]; then corepack enable pnpm && pnpm run build; \
  elif [ -f yarn.lock ]; then yarn build; \
  else npm run build; fi

# =========================================
# Stage 4 — Production
# =========================================
FROM node:22-alpine AS prod
WORKDIR /app
ENV NODE_ENV=production
COPY --from=builder /app/.output ./.output
COPY --from=builder /app/package.json ./package.json
EXPOSE 3000
CMD ["node", ".output/server/index.mjs"]