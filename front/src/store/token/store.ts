import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

type InitialState = {
  token: null | string;
};

const initialState: InitialState = {
  token: null,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_TOKEN:
      return { ...state, token: action.payload };
    default:
      return state;
  }
};

export default reducer;
