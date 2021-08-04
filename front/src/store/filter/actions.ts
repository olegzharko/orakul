import { Dispatch } from 'redux';
import getFilterData from '../../services/getFilterData';
import { State } from '../types';

export const ACTIONS = {
  SET_FILTER_INITIAL_DATA: 'SET_FILTER_INITIAL_DATA',
};

export const setFilterInitialData = (payload: any) => ({
  type: ACTIONS.SET_FILTER_INITIAL_DATA,
  payload,
});

export const fetchFilterData = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token, type } = getState().main.user;

  if (token && type) {
    const data = await getFilterData(token, type);
    dispatch(setFilterInitialData(data));
  }
};
