import { Dispatch } from 'redux';
import getImmovables from '../../services/generator/Immovable/getImmovables';
import { State } from '../types';

export const ACTIONS = {
  SET_IMMOVABLES: 'SET_IMMOVABLES',
  SET_LOADING: 'SET_LOADING',
};

export const setImmovables = (payload: any) => ({ type: ACTIONS.SET_IMMOVABLES, payload });
export const setIsLoading = (payload: boolean) => ({ type: ACTIONS.SET_LOADING, payload });

// Thunk actions
export const fetchImmovables = (id: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    dispatch(setIsLoading(true));
    const { success, data } = await getImmovables(token, id);

    if (success) {
      dispatch(setImmovables(data));
    }
    dispatch(setIsLoading(false));
  }
};
