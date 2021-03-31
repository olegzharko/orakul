import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type Developer = {
  id: number;
  title: string;
  full_name: string;
  tax_code: string;
  date: string;
  number: number;
  pass: number;
  prev: number;
  next: number;
  color?: string;
}

export type Immovable = {
  id: number;
  title: string;
  immovable_code: string;
  date: string;
  number: number;
  pass: number;
  prev: number;
  next: number;
}

export type DeveloperState = {
  date_info: string;
  developers: Developer[]
}

export type ImmovableState = {
  date_info: string;
  immovables: Immovable[];
}

export type RegistratorState = {
  isLoading: boolean,
  developers: DeveloperState | null,
  immovables: ImmovableState | null,
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
