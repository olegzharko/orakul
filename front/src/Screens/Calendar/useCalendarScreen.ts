/* eslint-disable import/prefer-default-export */
import { useEffect, useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import fetchCalendarData from '../../actions/fetchCalendarData';

const days = [1, 2, 3, 4, 5, 6];

export const useCalendarScreen = () => {
  const dispatch = useDispatch();
  const token = useSelector((state: any) => state.token.token);
  const { options, isLoading } = useSelector((state: any) => state.calendar);

  useEffect(() => {
    if (token && !isLoading) {
      fetchCalendarData(dispatch, token);
    }
  }, [token]);

  const rooms = useMemo(() => options?.rooms, [options]);
  const hours = useMemo(() => options?.work_time, [options]);

  const shouldLoad = useMemo(() => isLoading || (!rooms && !hours), [
    isLoading,
    rooms,
    hours,
  ]);

  const tableRaws = useMemo(() => new Array(rooms?.length || 0).fill(1), [
    rooms,
  ]);

  const tableCells = useMemo(
    () => new Array(hours?.length * days.length || 0).fill(1),
    [hours]
  );

  return {
    shouldLoad,
    rooms,
    hours,
    tableRaws,
    tableCells,
    days,
  };
};
