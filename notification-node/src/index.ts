import Fastify from 'fastify';
import { listenToNotifications } from './listener';

const server = Fastify({ logger: true });

server.get('/', async () => {
  return { status: 'Notification service running!' };
});

const start = async () => {
  try {
    await server.listen({ port: 3001 });
    console.log('Fastify server is running on http://localhost:3001');
    listenToNotifications();
  } catch (err) {
    server.log.error(err);
    process.exit(1);
  }
};

start();
