import { format } from 'date-fns';
import { VisionClientResponse, VisionNotaryRoom, VisionRoom } from './types';

export const formatClientTime = (time: string | null): string => {
  if (!time) return '';
  const date = new Date(time);

  return format(date, 'hh:mm');
};

export const formatRooms = (
  clients: VisionClientResponse[],
  rooms: VisionRoom[],
) => rooms.map(({ id, title }) => ({
  id,
  title,
  client: (clients || []).find((client) => client.room_id === id),
}));

export const formatNotaryRooms = (
  clients: VisionClientResponse[],
  rooms: VisionNotaryRoom[],
) => rooms.map(({ id, title, notary_id }) => ({
  id,
  title,
  notary_id,
  client: (clients || []).find((client) => client.room_id === id),
}));
