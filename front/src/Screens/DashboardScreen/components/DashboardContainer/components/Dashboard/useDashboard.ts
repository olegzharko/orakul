import { useDispatch, useSelector } from 'react-redux';
/* eslint-disable no-shadow */
import { useEffect, useState } from 'react';
import { UserTypes } from '../../../../../../types';
import { fetchAppointments, setAppointments } from '../../../../../../store/appointments/actions';
import { State } from '../../../../../../store/types';

export enum DashboardViewType {
  CARDS,
  TABLE
}

const useDashboard = () => {
  const dispatch = useDispatch();
  const [selectedType, setSelectedType] = useState<DashboardViewType>(DashboardViewType.CARDS);
  const { appointments, isLoading } = useSelector((state: State) => state.appointments);

  useEffect(() => {
    dispatch(fetchAppointments(UserTypes.PRINTER));

    return () => { dispatch(setAppointments([])); };
  }, []);

  return { selectedType, setSelectedType, appointments, isLoading };
};

export default useDashboard;
