import { Dispatch } from 'redux';
import getDevelopers from '../../services/registrator/getDevelopers';
import getImmovables from '../../services/registrator/getImmovables';
import getPowerOfAttorney from '../../services/notarize/getPowerOfAttorney';
import putDeveloper, { EditDeveloperProps } from '../../services/registrator/putDeveloper';
import putImmovable from '../../services/registrator/putImmovable';
import putPowerOfAttorney, { EditPowerOfAttorneyProps } from '../../services/notarize/putPowerOfAttorney';
import { setModalInfo } from '../main/actions';
import { State } from '../types';
import { Developer, Immovable, PowerOfAttorney } from './store';

export const ACTIONS = {
  SET_LOADING: 'SET_LOADING',
  SET_DEVELOPERS: 'SET_DEVELOPERS',
  SET_IMMOVABLES: 'SET_IMMOVABLES',
  SET_POWER_OF_ATTORNEY: 'SET_POWER_OF_ATTORNEY',
};

const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_LOADING,
  payload,
});

const setDevelopers = (payload: Developer) => ({ type: ACTIONS.SET_DEVELOPERS, payload });
const setImmovables = (payload: Immovable) => ({ type: ACTIONS.SET_IMMOVABLES, payload });
const setPowerOfAttorneys = (payload: PowerOfAttorney) => ({
  type: ACTIONS.SET_POWER_OF_ATTORNEY, payload
});

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

export const fetchPowerOfAttorneys = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  dispatch(setIsLoading(true));
  const { token } = getState().main.user;

  if (token) {
    const { success, data } = await getPowerOfAttorney(token);

    if (success) {
      dispatch(setPowerOfAttorneys(data));
    }
  }
  dispatch(setIsLoading(false));
};

export const editDeveloperStatus = (id: string, bodyData: EditDeveloperProps) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const { success, message } = await putDeveloper(token, id, bodyData);

    dispatch(
      setModalInfo({
        open: true,
        success,
        message,
      })
    );
  }
};

export const editImmovableStatus = (id: string, bodyData: EditDeveloperProps) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const { success, message } = await putImmovable(token, id, bodyData);

    dispatch(
      setModalInfo({
        open: true,
        success,
        message,
      })
    );
  }
};

export const editPowerOfAttorneyStatus = (id: string, bodyData: EditPowerOfAttorneyProps) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const { success, message } = await putPowerOfAttorney(token, id, bodyData);

    dispatch(
      setModalInfo({
        open: true,
        success,
        message,
      })
    );
  }
};
