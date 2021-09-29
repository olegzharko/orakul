import { useCallback, useMemo } from 'react';
import { useHistory } from 'react-router';

import { VisionNavigationLinks } from '../../../../enums';

import { VisionClientResponse } from '../../types';

export type WaitingRoomCardProps = {
  title: string;
  client: VisionClientResponse;
  roomId: number;
  toReception: (roomId: number, client: VisionClientResponse) => void;
  onFinish: (dealId: number) => void;
  isNotary?: boolean;
  toNotary?: (roomId: number, client: VisionClientResponse) => void;
}

export const useWaitingRoomClientCard = ({
  title,
  client,
  isNotary,
  roomId,
  toReception,
  toNotary,
  onFinish
} : WaitingRoomCardProps) => {
  const history = useHistory();

  // Memo
  const representativeTitleColor = useMemo(() => {
    let color = 'green';
    let title = 'Запрошено';

    if (!client.representative_arrived) {
      color = 'red';
      title = 'Очікує дзвінка';
    }

    return { color, title };
  }, [client.representative_arrived]);

  // Callbacks
  const handleMoreClick = useCallback(() => {
    history.push(`${VisionNavigationLinks.clientSide}/${client.deal_id}`);
  }, [client.deal_id, history]);

  const handleToReceptionClick = useCallback(() => {
    toReception(roomId, client);
  }, [toReception, roomId, client]);

  const handleFinishClick = useCallback(() => {
    onFinish(client.deal_id);
  }, [client.deal_id, onFinish]);

  const handleToNotaryClick = useCallback(() => {
    if (!toNotary) return;

    toNotary(roomId, client);
  }, [toNotary, roomId, client]);

  return {
    title,
    client,
    isNotary,
    representativeTitleColor,
    handleMoreClick,
    handleToReceptionClick,
    handleFinishClick,
    handleToNotaryClick,
  };
};
