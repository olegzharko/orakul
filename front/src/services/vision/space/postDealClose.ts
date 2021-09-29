import { VisionClientResponse } from '../../../Screens/VisionScreen/components/ClientSide/types';

import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function postDealClose(
  token: string,
  dealId: number,
) {
  const data = await requestApi({
    url: `${DEFAULT_URL}/api/deal/close/${dealId}`,
    headers: { Authorization: `Bearer ${token}` },
    method: 'POST',
  });

  if (!data.success) throw new Error('Завершити послугу не вдалось: проблема на боці сервера.');

  return data.data;
}
