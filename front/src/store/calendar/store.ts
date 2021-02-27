import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

type InitialState = {
  options: any;
  isLoading: boolean;
};

const initialState: InitialState = {
  options: null,
  isLoading: false,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_OPTIONS:
      return { ...state, options: action.payload };
    case ACTIONS.SET_IS_LOADING:
      return { ...state, isLoading: action.payload };
    default:
      return state;
  }
};

export default reducer;
