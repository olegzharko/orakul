import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type Developer = {
  date_info: string;
  developers: {
    id: number;
    title: string;
    full_name: string;
    tax_code: number;
    date: string;
    number: number;
    pass: number;
    prew: number;
    next: number;
    color?: string;
  }[]
}

export type Immovable = {
  date_info: string;
  immovables: {
    id: number;
    title: string;
    immovable_code: number;
    date: string;
    number: number;
    pass: number;
    prew: number;
    next: number;
  }[]
}

export type RegistratorState = {
  isLoading: boolean,
  developers: Developer | null,
  immovables: Immovable | null,
};

const initialState: RegistratorState = {
  isLoading: false,
  developers: null,
  immovables: null,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_LOADING:
      return { ...state, isLoading: action.payload };
    case ACTIONS.SET_DEVELOPERS:
      return { ...state, developers: action.payload };
    case ACTIONS.SET_IMMOVABLES:
      return { ...state, immovables: action.payload };
    default:
      return state;
  }
};

export default reducer;
