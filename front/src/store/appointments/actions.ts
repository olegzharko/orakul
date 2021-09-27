import { Dispatch } from 'redux';
import { FilterData, State } from '../types';

import getAppointments from '../../services/getAppointments';
import searchAppointmentsServices from '../../services/searchAppointments';
import getCardsByContractType from '../../services/generator/getCardsByContractType';
import postAppointmentsByFilter from '../../services/postAppointmentsByFilter';

export const ACTIONS = {
  SET_LOADING: 'SET_LOADING',
  SET_APPOINTMENTS: 'SET_APPOINTMENTS',
  ADD_NEW_APPOINTMENT: 'ADD_NEW_APPOINTMENT',
  EDIT_APPOINTMENTS: 'EDIT_APPOINTMENTS',
  DELETE_APPOINTMENT: 'DELETE_APPOINTMENT',
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

export const setEditAppointments = (payload: any) => ({
  type: ACTIONS.EDIT_APPOINTMENTS,
  payload,
});

export const deleteAppointment = (id: string) => ({
  type: ACTIONS.DELETE_APPOINTMENT,
  payload: id,
});

export const clearAppointments = () => async (
  dispatch: Dispatch<any>,
) => {
  dispatch(setIsLoading(true));
  dispatch(setAppointments([]));
};

export const fetchAppointments = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token, type, id } = getState().main.user;

  if (token && type && id) {
    dispatch(setIsLoading(true));
    const res = await getAppointments(token, type);

    if (res?.success) {
      const { data } = res;
      dispatch(setAppointments(Object.values(data)));
    }

    dispatch(setIsLoading(false));
  }
};

export const fetchAppointmentsByFilter = (bodyData: FilterData) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token, type } = getState().main.user;

  if (token && type) {
    const res = await postAppointmentsByFilter(token, { ...bodyData, user_type: type });

    if (res?.success) {
      const { data } = res;
      dispatch(setAppointments(Object.values(data)));
    }
  }
};

export const fetchAppointmentsByContracts = (url: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const res = await getCardsByContractType(token, url);

    if (res?.success) {
      const { data } = res;
      dispatch(setAppointments(Object.values(res.data)));
    }
  }
};

export const searchAppointments = (text: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token, type } = getState().main.user;

  if (!token || !type) {
    throw new Error(`missed token or type in searchAppointments. Token: ${token}, Type: ${type}`);
  }

  if (token && type) {
    const res = await searchAppointmentsServices(token, { text, type });

    if (res?.success) {
      const { data } = res;
      dispatch(setAppointments(Object.values(data)));
    }
  }
};
