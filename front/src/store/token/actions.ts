import { Dispatch } from 'redux';
import getToken from '../../services/getToken';
import { State } from '../types';

export const ACTIONS = {
  SET_TOKEN: 'SET_TOKEN',
  SET_LOADING: 'SET_LOADING',
};

export const setToken = (payload: string) => ({
  type: ACTIONS.SET_TOKEN,
  payload,
});

// Thunk actions
export const fetchToken = () => async (dispatch: Dispatch<any>) => {
  const token = await getToken();
  dispatch(setToken(token));
};
