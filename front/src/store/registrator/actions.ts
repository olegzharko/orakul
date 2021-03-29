import { Dispatch } from 'redux';
import getDevelopers from '../../services/registrator/getDevelopers';
import getImmovables from '../../services/registrator/getImmovables';
import { State } from '../types';
import { Developer, Immovable } from './store';

export const ACTIONS = {
  SET_LOADING: 'SET_LOADING',
  SET_DEVELOPERS: 'SET_DEVELOPERS',
  SET_IMMOVABLES: 'SET_IMMOVABLES',
};

const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_LOADING,
  payload,
});

const setDevelopers = (payload: Developer) => ({ type: ACTIONS.SET_DEVELOPERS, payload });
const setImmovables = (payload: Immovable) => ({ type: ACTIONS.SET_IMMOVABLES, payload });

export const fetchDevelopers = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  dispatch(setIsLoading(true));
  const { token } = getState().main.user;

  if (token) {
    const { success, data } = await getDevelopers(token);

    if (success) {
      dispatch(setDevelopers(data));
    }
  }
  dispatch(setIsLoading(false));
};

export const fetchImmovables = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  dispatch(setIsLoading(true));
  const { token } = getState().main.user;

  if (token) {
    const { success, data } = await getImmovables(token);

    if (success) {
      dispatch(setImmovables(data));
    }
  }
  dispatch(setIsLoading(false));
};
