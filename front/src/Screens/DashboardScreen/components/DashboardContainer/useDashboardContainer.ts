import { useEffect, useMemo, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { fetchAppointments, clearAppointments } from '../../../../store/appointments/actions';
import { State } from '../../../../store/types';

export const useDashboardContainer = () => {
  const dispatch = useDispatch();
  const { appointments, isLoading } = useSelector((state: State) => state.appointments);
  const { type } = useSelector((state: State) => state.main.user);

  useEffect(() => {
    dispatch(fetchAppointments());

    return () => {
      dispatch(clearAppointments());
    };
  }, [type]);

  const isAppointmentsEmpty = useMemo(() => !appointments.length, [appointments]);

  const formatAppointments = useMemo(() => appointments.map((item: any) => ({
    title: `${item.day || ''} ${item.date || ''}`,
    cards: item.cards?.map((card: any) => ({
      id: card.id,
      title: card.title,
      content: card.instructions,
      color: card.color,
    }))
  })), [appointments]);

  return {
    formatAppointments,
    isLoading,
    isAppointmentsEmpty
  };
};
