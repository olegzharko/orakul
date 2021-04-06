import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

type ClientCardInfo = {
  full_name: string;
  id: number;
  list: string[];
}

export type GenerateClient = {
  client: null | ClientCardInfo,
  representative: null | ClientCardInfo,
  spouse: null | ClientCardInfo,
}

export type ClientsState = {
  clients: GenerateClient[];
  isLoading: false;
};

const initialState: ClientsState = {
  clients: [],
  isLoading: false,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_LOADING:
      return { ...state, idLoading: action.payload };
    case ACTIONS.SET_CLIENTS:
      return { ...state, clients: action.payload };
    default:
      return state;
  }
};

export default reducer;
