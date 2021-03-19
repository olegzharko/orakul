import { Dispatch } from 'redux';
import getToken from '../../services/getToken';
import login from '../../services/login/Login';
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

export const sendLogin = (data: { email: string; password: string }) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

  if (token) {
    const res = await login(token, data);

    console.log(res);
  }
};
