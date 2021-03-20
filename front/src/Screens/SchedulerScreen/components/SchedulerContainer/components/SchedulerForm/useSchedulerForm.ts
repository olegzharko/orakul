/* eslint-disable prettier/prettier */
import { useSelector } from 'react-redux';
import { useState, useEffect } from 'react';
import { State } from '../../../../../../store/types';

export const useSchedulerForm = () => {
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
    setSelectedTab
  };
};
