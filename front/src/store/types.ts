import { CalendarState } from './calendar/store';
import { TokenState } from './token/store';

export type REDUX_ACTION = {
  type: string;
  payload: any;
};

export type State = {
  calendar: CalendarState;
  token: TokenState;
};
