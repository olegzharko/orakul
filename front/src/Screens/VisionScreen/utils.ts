import { format, getHours, getMinutes, getSeconds, sub } from 'date-fns';

export const getWaitingTime = (visitTime: string | null): string => {
  if (!visitTime) return '';

  const startTime = new Date(visitTime);
  const now = new Date();

  return format(sub(now, {
    hours: getHours(startTime),
    minutes: getMinutes(startTime),
  }), 'hh:mm');
};
