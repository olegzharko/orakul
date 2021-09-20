import { VisionClientResponse } from './types';

const formatByLength = (
  time: number
): number | string => (time.toString().length === 1 ? `0${time}` : time);

const formatClientTime = (time: string | null): string => {
  if (!time) return '';

  const date = new Date(time);
  const hours = date.getHours();
  const minutes = date.getMinutes();

  return `${formatByLength(hours)}:${formatByLength(minutes)}`;
};

export const formatReceptionData = (
  reception: VisionClientResponse[]
) => reception.map((reception) => ({
  id: reception.card_id,
  start_time: formatClientTime(reception.start_time),
  visit_time: formatClientTime(reception.visit_time),
  waiting_time: formatClientTime(reception.waiting_time),
  people: reception.number_of_people,
  children: reception.children,
  in_progress: reception.in_progress,
  representative: reception.representative,
  notary: reception.notary,
  reader: reception.reader,
  accompanying: reception.accompanying,
  immovable: reception.immovable,
  buyer: reception.buyer,
}));
