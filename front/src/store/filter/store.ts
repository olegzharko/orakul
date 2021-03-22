import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type FilterState = {
  filterInitialData: any;
};

const initialState: FilterState = {
  filterInitialData: null,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_FILTER_INITIAL_DATA:
      return { ...state, filterInitialData: action.payload };
    default:
      return state;
  }
};

export default reducer;
