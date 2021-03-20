import { Dispatch } from 'redux';
import getToken from '../../services/getToken';
import login from '../../services/login/Login';
import forgotPasswordService from '../../services/login/forgotPassword';
import resetPasswordService, {
  ResetPasswordType,
} from '../../services/login/resetPassword';

export const ACTIONS = {
  SET_TOKEN: 'SET_TOKEN',
  SET_USER: 'SET_USER',
  SET_LOADING: 'SET_LOADING',
  SET_MODAL_INFO: 'SET_MODAL_INFO',
};

export const setToken = (payload: string) => ({
  type: ACTIONS.SET_TOKEN,
  payload,
});

export const setLogin = (payload: string) => ({
  type: ACTIONS.SET_TOKEN,
  payload,
});

export const setUser = (payload: any) => ({
  type: ACTIONS.SET_USER,
  payload,
});

export const setModalInfo = (payload: any) => ({
  type: ACTIONS.SET_MODAL_INFO,
  payload,
});

// Thunk actions
export const fetchToken = () => async (dispatch: Dispatch<any>) => {
  const token = await getToken();
  dispatch(setToken(token));
};

export const sendLogin = (
  bodyData: {
    email: string;
    password: string;
  },
  remember: boolean
) => async (dispatch: Dispatch<any>) => {
  const { success, data } = await login(bodyData);
  if (success) {
    dispatch(setToken(data.token));
    dispatch(setUser(data));
  }

  if (remember) localStorage.setItem('user', JSON.stringify(data));
};

export const forgotPassword = ({ email }: { email: string }) => async (
  dispatch: Dispatch<any>
) => {
  const { success, message } = await forgotPasswordService({ email });

  if (success) dispatch(setModalInfo({ success, message, open: true }));
};

export const resetPassword = (data: ResetPasswordType) => async (
  dispatch: Dispatch<any>
) => {
  const { success, message } = await resetPasswordService(data);

  if (success) dispatch(setModalInfo({ success, message, open: true }));
};
