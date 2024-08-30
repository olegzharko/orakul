export type ImmovableItem = {
  contract_type_id: number | null;
  building_id: number | null;
  imm_type_id: number | null;
  imm_number: string | null;
  bank: boolean;
  proxy: boolean;
};

export type ImmovableItems = ImmovableItem[];

export type SelectItem = {
  id: number;
  title: string;
};

export type ClientItem = {
  phone: string | null;
  full_name: string | null;
};

export type NewCard = {
  immovables: ImmovableItems;
  clients: ClientItem[];
  date_time: string;
  dev_company_id: number | null;
  dev_representative_id: number | null;
  dev_manager_id: number | null;
  room_id: number;
  notary_id: number | null;
};

// eslint-disable-next-line no-shadow
export enum UserTypes {
  GENERATOR = 'generator',
  RECEPTION = 'reception',
  MANAGER = 'manager',
  ASSISTANT = 'assistant',
  REGISTRATOR = 'registrator',
  VISION = 'vision',
  BANK = 'bank',
  DEVELOPER = 'developer',
  NOTARIZE = 'notarize',
}

export type ManagerAppointmentCard = {
  id: number;
  color: string;
  instructions: string[];
  short_info: {
    dev_representative_id: string;
    notary: string;
    notary_assistant_giver: string;
    notary_assistant_reader: string;
  };
  title: string;
};

export type ManagerAppointment = {
  day: string;
  date: string;
  cards: ManagerAppointmentCard[];
};

export type ManagerAppointments = ManagerAppointment[];

export type DefaultContentItem = {
  title: string;
  value: string;
}
