export type SelectItem = {
  id: number;
  title: string;
};

export type ImmovableItem = {
  contract_type_id: number | undefined;
  building_id: number | undefined;
  imm_type_id: number | undefined;
  imm_num: number | undefined;
  bank: boolean;
  proxy: boolean;
};

export type ImmovableItems = ImmovableItem[];

export type ImmovableItemKey = keyof ImmovableItem;

export const immovableItem: ImmovableItem = {
  contract_type_id: undefined,
  building_id: undefined,
  imm_type_id: undefined,
  imm_num: undefined,
  bank: false,
  proxy: false,
};

export type ClientItem = {
  phone: string;
  full_name: string;
};

export const clientItem: ClientItem = {
  phone: '',
  full_name: '',
};
