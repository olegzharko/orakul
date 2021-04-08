import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

type ImmovableCardsType = {
  id: number,
  title: string,
  list: string[],
}

export type ImmovablesState = {
  immovables: ImmovableCardsType[];
  isLoading: false;
};

const initialState: ImmovablesState = {
  immovables: [],
  isLoading: false,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_LOADING:
      return { ...state, idLoading: action.payload };
    case ACTIONS.SET_IMMOVABLES:
      return { ...state, immovables: action.payload };
    default:
      return state;
  }
};

export default reducer;
