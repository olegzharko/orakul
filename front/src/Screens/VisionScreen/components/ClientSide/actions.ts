import getSpaceInfo from '../../../../services/vision/getSpaceInfo';
import { formatReceptionData } from './utils';

export const loadSpaceInfo = async (token: string) => {
  const res = await getSpaceInfo(token);

  if (res.success) {
    const { reception } = res.data;
    return [formatReceptionData(reception)];
  }

  return [];
};
