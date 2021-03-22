import { Dispatch } from 'redux';
import { FilterData, State } from '../types';
import getAppointments from '../../services/getAppointments';
import setSchedulerFilter from '../../services/setSchedulerFilter';
import searchAppointmentsServices from '../../services/searchAppointments';

export const ACTIONS = {
  SET_LOADING: 'SET_LOADING',
  SET_APPOINTMENTS: 'SET_APPOINTMENTS',
  ADD_NEW_APPOINTMENT: 'ADD_NEW_APPOINTMENT',
  EDIT_APPOINTMENTS: 'EDIT_APPOINTMENTS',
};

export const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_LOADING,
  payload,
});

export const setAppointments = (payload: any) => ({
  type: ACTIONS.SET_APPOINTMENTS,
  payload,
});

export const addNewAppointment = (payload: any) => ({
  type: ACTIONS.ADD_NEW_APPOINTMENT,
  payload,
});

export const setEditAppointmens = (payload: any) => ({
  type: ACTIONS.EDIT_APPOINTMENTS,
  payload,
});

export const fetchAppointments = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    dispatch(setIsLoading(true));
    const data = await getAppointments(token);

    dispatch(setAppointments(Object.values(data)));
    dispatch(setIsLoading(false));
  }
};

export const fetchAppointmentsByFilter = (place: string, bodyData: FilterData) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const { data, success } = await setSchedulerFilter(place, token, bodyData);

    if (success) {
      dispatch(setAppointments(Object.values(data)));
    }
  }
};

export const searchAppointments = (text: string, page: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const { success, data } = await searchAppointmentsServices(token, {
      text,
      page,
    });

    if (success) {
      dispatch(setAppointments(data));
    }
  }
};
