import getCardsByContractType from '../../../../services/generator/getCardsByContractType';
import getAppointments from '../../../../services/getAppointments';
import { UserTypes } from '../../../../types';

import { formatClientsCards } from './utils';

export const loadClientCards = async (token: string, history: any) => {
  const res = await getAppointments(token, UserTypes.GENERATOR);

  if (res.success) {
    return formatClientsCards(res.data, history);
  }

  return [];
};

export const loadClientsCardsByContract = async (token: string, url: string, history: any) => {
  const res = await getCardsByContractType(token, url);
  if (res.success) {
    return formatClientsCards(res.data, history);
  }

  return [];
};
