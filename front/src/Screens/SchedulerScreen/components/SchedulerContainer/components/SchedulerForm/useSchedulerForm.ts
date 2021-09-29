import { useCallback, useState, useEffect } from 'react';
/* eslint-disable prettier/prettier */
import { useSelector, useDispatch } from 'react-redux';
import { State } from '../../../../../../store/types';
import { setEditAppointmentData, setSelectedOldAppointment } from '../../../../../../store/scheduler/actions';

export const useSchedulerForm = () => {
  const dispatch = useDispatch();
  const [selectedTab, setSelectedTab] = useState(0);

  const newSelectedAppointment = useSelector(
    (state: State) => state.scheduler.newSelectedAppointment
  );
  const oldSelectedAppointment = useSelector(
    (state: State) => state.scheduler.oldSelectedAppointment
  );
  const editAppointmentData = useSelector(
    (state: State) => state.scheduler.editAppointmentData
  );

  const onCloseTab = useCallback(() => {
    dispatch(setSelectedOldAppointment(null));
    dispatch(setEditAppointmentData(null));
  }, [dispatch]);

  useEffect(() => {
    setSelectedTab(editAppointmentData ? 1 : 0);
  }, [editAppointmentData]);

  useEffect(() => {
    setSelectedTab(0);
  }, [newSelectedAppointment]);

  return {
    newSelectedAppointment,
    oldSelectedAppointment,
    editAppointmentData,
    selectedTab,
    setSelectedTab,
    onCloseTab,
  };
};
