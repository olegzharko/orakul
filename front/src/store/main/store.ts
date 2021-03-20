import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type User = {
  type: string | null;
  token: null | string;
};

export type ModalInfo = {
  open: boolean;
  success: boolean;
  message: string;
};

export type MainState = {
  user: User;
  modalInfo: ModalInfo;
};

const initialState: MainState = {
  user: {
    type: null,
    token: null,
  },
  modalInfo: {
    open: false,
    success: false,
    message: '',
  },
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_USER:
      return { ...state, user: { ...state.user, ...action.payload } };
    case ACTIONS.SET_MODAL_INFO:
      return { ...state, modalInfo: action.payload };
    default:
      return state;
  }
};

export default reducer;
