import { useCallback, useEffect, useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { UserTypes } from '../../../../../../types';
import {
  setSelectedOldAppointment,
  fetchCalendarCard,
  fetchSchedulerSettings,
  moveCalendarCard,
} from '../../../../../../store/scheduler/actions';
import { clearAppointments, fetchAppointments } from '../../../../../../store/appointments/actions';
import { State } from '../../../../../../store/types';
import formatAppointmentDate from './utils/formatAppointmentDate';

export const useSchedulerTable = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { options, isLoading } = useSelector((state: State) => state.scheduler);
  const { appointments } = useSelector((state: State) => state.appointments);

  useEffect(() => {
    dispatch(fetchSchedulerSettings());
    dispatch(fetchAppointments());

    return () => {
      dispatch(clearAppointments());
    };
  }, [dispatch, token]);

  const rooms = useMemo(() => options?.rooms, [options]);
  const hours = useMemo(() => options?.work_time, [options]);

  const shouldLoad = useMemo(() => isLoading || !options, [isLoading, options]);

  const tableColumns = useMemo(() => new Array(rooms?.length || 0).fill(1), [
    rooms,
  ]);

  const days = useMemo(() => options?.day_and_date, [options]);

  const tableRows = useMemo(
    () => new Array(hours?.length * days?.length || 0).fill(1),
    [days?.length, hours?.length]
  );

  const handleAppointmentDrag = useCallback(
    (appointment) => {
      const payload = formatAppointmentDate(
        hours,
        rooms,
        days,
        appointment.y,
        appointment.x
      );

      const date_time = `${payload.year}.${payload.date}. ${payload.time}`;

      const data = {
        date_time,
        room_id: payload.room,
      };

      dispatch(moveCalendarCard(data, appointment.i));
    },
    [hours, rooms, days, dispatch]
  );

  const onAppointmentClick = useCallback(
    async ({ x, y, i }: any) => {
      const payload = formatAppointmentDate(hours, rooms, days, y, x);

      dispatch(fetchCalendarCard(i));

      dispatch(
        setSelectedOldAppointment({
          ...payload,
          raw: y,
          cell: x,
          i,
          date: payload.date,
        })
      );
    },
    [hours, rooms, days, dispatch]
  );

  return {
    shouldLoad,
    rooms,
    hours,
    tableRows,
    tableColumns,
    days,
    appointments,
    handleAppointmentDrag,
    onAppointmentClick,
  };
};
