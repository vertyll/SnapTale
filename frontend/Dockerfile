ARG NODE_VERSION=22

# Base stage
FROM node:${NODE_VERSION}-alpine AS base

WORKDIR /app

RUN corepack enable && corepack prepare pnpm@10.25.0 --activate
RUN apk add --no-cache libc6-compat

# Dependencies stage
FROM base AS deps

COPY package.json pnpm-lock.yaml ./

RUN pnpm install --frozen-lockfile

# Build stage
FROM base AS build

# Build arguments for environment
ARG API_BASE_URL=http://localhost:8000
ARG FRONTEND_URL=http://localhost:3000

COPY package.json pnpm-lock.yaml ./

RUN pnpm install --frozen-lockfile

COPY . .

# Set environment variables for build
ENV API_BASE_URL=${API_BASE_URL}

# Build the application
RUN pnpm run build

# Production stage
FROM node:${NODE_VERSION}-alpine AS production

WORKDIR /app

RUN apk add --no-cache curl

# Copy built application
COPY --from=build /app/.output /app/.output
COPY --from=build /app/package.json /app/

ENV NODE_ENV=production
ENV HOST=0.0.0.0
ENV PORT=3000

EXPOSE 3000

HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:3000 || exit 1

CMD ["node", ".output/server/index.mjs"]
