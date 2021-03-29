import { useEffect, useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { setAppointments, fetchAppointments } from '../../../../store/appointments/actions';
import { UserTypes } from '../../../../types';
import { State } from '../../../../store/types';

export const useDashboardContainer = () => {
  const dispatch = useDispatch();
  const { appointments } = useSelector((state: State) => state.appointments);

  useEffect(() => {
    dispatch(fetchAppointments());

    return () => { dispatch(setAppointments([])); };
  }, []);

  const formatAppointments = useMemo(() => appointments.map((item: any) => ({
    title: `${item.day} ${item.date}`,
    cards: item.cards.map((card: any) => ({
      id: card.id,
      title: card.title,
      content: card.instructions,
      color: card.color,
    }))
  })), [appointments]);

  return { formatAppointments };
};
