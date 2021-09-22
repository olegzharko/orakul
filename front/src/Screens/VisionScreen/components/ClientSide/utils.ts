import { VisionClientResponse, VisionRoom } from './types';

const formatByLength = (
  time: number
): number | string => (time.toString().length === 1 ? `0${time}` : time);

export const formatClientTime = (time: string | null): string => {
  if (!time) return '';

  const date = new Date(time);
  const hours = date.getHours();
  const minutes = date.getMinutes();

  return `${formatByLength(hours)}:${formatByLength(minutes)}`;
};

export const formatRooms = (
  clients: VisionClientResponse[],
  rooms: VisionRoom[],
) => rooms.map(({ id, title }) => ({
  id,
  title,
  client: clients.find((client) => client.room_id === id),
}));
