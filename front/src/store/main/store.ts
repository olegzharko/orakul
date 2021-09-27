import { UserTypes } from '../../types';
import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

type ExtraType = {
  title: string;
  type: UserTypes;
}

export type User = {
  type: UserTypes | null;
  token: null | string;
  id: number | null;
  extra_type: ExtraType[];
  user_name: string;
  avatar: string;
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
    id: null,
    extra_type: [],
    user_name: '',
    avatar: '',
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
    case ACTIONS.SET_USER_TYPE:
      return { ...state, user: { ...state.user, type: action.payload } };
    default:
      return state;
  }
};

export default reducer;
