import { ClientItem, ImmovableItem } from '../../../../../../../../types';

export type ImmovableItemKey = keyof ImmovableItem;

export const immovableItem: ImmovableItem = {
  contract_type_id: undefined,
  building_id: undefined,
  imm_type_id: undefined,
  imm_num: undefined,
  bank: false,
  proxy: false,
};

export const clientItem: ClientItem = {
  phone: '',
  full_name: '',
};
