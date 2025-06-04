import Redis from 'ioredis';
import axios from 'axios';

const redis = new Redis(); // default: 127.0.0.1:6379

export function listenToNotifications() {
  redis.subscribe('notifications', (err, count) => {
    if (err) {
      console.error('Failed to subscribe:', err);
    } else {
      console.log(`Subscribed to ${count} channel(s). Listening for notifications...`);
    }
  });

  redis.on('message', async (channel, message) => {
    try {
      const data = JSON.parse(message);
      console.log(`Received notification:`, data);

      console.log(`Sending notification to user ${data.user_id}: "${data.message}"`);

      await axios.post('http://localhost:8000/api/notifications/processed', {
        id: data.id,
      });

      console.log(`Notification ${data.id} processed successfully`);

    } catch (error) {
      console.error('Failed to process message:', error);
    }
  });
}
