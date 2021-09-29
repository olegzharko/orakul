import { VisionClientResponse } from '../../../Screens/VisionScreen/components/ClientSide/types';

import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function postMoveToNotary(
  token: string,
  dealId: number,
) {
  const data = await requestApi({
    url: `${DEFAULT_URL}/api/deal/move/to/notary/${dealId}`,
    headers: { Authorization: `Bearer ${token}` },
    method: 'POST',
  });

  if (!data.success) throw new Error('Перемістити клієнта не вдалось: проблема на боці сервера.');

  return data.data;
}
