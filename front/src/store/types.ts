import { ClientsState } from './clients/store';
import { RegistratorState } from './registrator/store';
import { FilterState } from './filter/store';
import { SchedulerState } from './scheduler/store';
import { MainState } from './main/store';
import { AppointmentsState } from './appointments/store';
import { ImmovablesState } from './immovables/store';

export type REDUX_ACTION = {
  type: string;
  payload: any;
};

export type State = {
  scheduler: SchedulerState;
  main: MainState;
  appointments: AppointmentsState;
  filter: FilterState;
  registrator: RegistratorState;
  clients: ClientsState;
  immovables: ImmovablesState;
};

export type FilterData = {
  notary_id: string | null,
  reader_id: string | null,
  accompanying_id: string | null,
  contract_type_id: string | null,
  developer_id: string | null,
  dev_representative_id: string | null,
  sort_type?: string | null,
};
