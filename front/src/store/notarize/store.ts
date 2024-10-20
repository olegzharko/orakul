import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type Developer = {
  id: number;
  title: string;
  full_name: string;
  tax_code: string;
  date: string;
  number: number;
  pass: boolean;
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
  pass: boolean;
  prev: number;
  next: number;
}

export type PowerOfAttorney = {
  id: number;
  title: string;
  full_name: string;
  tax_code: string;
  date: string;
  number: number;
  pass: boolean;
  prev: number;
  next: number;
  color?: string;
}

export type DeveloperState = {
  date_info: string;
  developers: Developer[]
}

export type ImmovableState = {
  date_info: string;
  immovables: Immovable[];
}

export type PowerOfAttorneyState = {
  date_info: string;
  powerOfAttorneys: PowerOfAttorney[]
}

export type NotarizeState = {
  isLoading: boolean,
  developers: DeveloperState | null,
  immovables: ImmovableState | null,
  powerOfAttorneys: PowerOfAttorneyState | null,
};

const initialState: NotarizeState = {
  isLoading: false,
  developers: null,
  immovables: null,
  powerOfAttorneys: null,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_LOADING:
      return { ...state, isLoading: action.payload };
    case ACTIONS.SET_DEVELOPERS:
      return { ...state, developers: action.payload };
    case ACTIONS.SET_IMMOVABLES:
      return { ...state, immovables: action.payload };
    case ACTIONS.SET_POWER_OF_ATTORNEY:
      return { ...state, powerOfAttorneys: action.payload };
    default:
      return state;
  }
};

export default reducer;
