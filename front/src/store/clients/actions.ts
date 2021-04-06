import { Dispatch } from 'redux';
import getClients from '../../services/generator/Client/getClients';
import { State } from '../types';

export const ACTIONS = {
  SET_CLIENTS: 'SET_CLIENTS',
  SET_LOADING: 'SET_LOADING',
};

export const setClients = (payload: any) => ({ type: ACTIONS.SET_CLIENTS, payload });
export const setIsLoading = (payload: boolean) => ({ type: ACTIONS.SET_LOADING, payload });

// Thunk actions
export const fetchClients = (id: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    dispatch(setIsLoading(true));
    const { success, data } = await getClients(token, id);

    if (success) {
      dispatch(setClients(data));
    }
    dispatch(setIsLoading(false));
  }
};
