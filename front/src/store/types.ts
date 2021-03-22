import { FilterState } from './filter/store';
import { SchedulerState } from './scheduler/store';
import { MainState } from './main/store';
import { AppointmentsState } from './appointments/store';

export type REDUX_ACTION = {
  type: string;
  payload: any;
};

export type State = {
  scheduler: SchedulerState;
  main: MainState;
  appointments: AppointmentsState;
  filter: FilterState;
};

export type FilterData = {
  notary_id: string | null,
  reader_id: string | null,
  giver_id: string | null,
  contract_type_id: string | null,
  developer_id: string | null,
  dev_assistant_id: string | null,
};
