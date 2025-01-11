import { NextConfig } from "next";
import fs from 'fs';

interface ServerOptions {
  key: Buffer;
  cert: Buffer;
}

interface ServerConfig {
  type: 'https';
  options: ServerOptions;
}

interface CustomWebpackDevMiddlewareConfig {
  server: ServerConfig;
}

const nextConfig: NextConfig = {
  webpackDevMiddleware: (config: CustomWebpackDevMiddlewareConfig) => {
      config.server = {
          type: 'https',
          options: {
              key: fs.readFileSync('./localhost-key.pem'),
              cert: fs.readFileSync('./localhost.pem'),
          },
      };
      return config;
  },
  reactStrictMode: true, // Enable React strict mode and double check for any issues
};

export default nextConfig;
