import { useCallback, useMemo, useState } from 'react';
import { WaitingRoomGroupCardClient } from '../../types';

export type WaitingRoomGroupCardProps = {
  title: string;
  roomId: number;
  clients: WaitingRoomGroupCardClient[];
  isNotary?: boolean;
  notary_id?: number;
}

export const useWaitingRoomGroupCard = ({
  title,
  clients,
  roomId,
  isNotary,
  notary_id,
}: WaitingRoomGroupCardProps) => {
  const [selected, setSelected] = useState<number | undefined>();

  // Memo
  const filteredCards = useMemo(() => {
    if (isNotary) {
      return clients.filter((client) => client.notary_id === notary_id);
    }

    return clients;
  }, [notary_id, clients, isNotary]);

  // Callbacks
  const handleCall = useCallback(() => {
    if (!selected) {
      alert('Виберіть клієнта, який знаходится в даній кімнаті');
      return;
    }

    const selectedClient = clients.find(({ id }) => id === selected);
    if (!selectedClient) throw new Error(`Can't find client with id: ${selected}`);

    selectedClient.onCall(roomId, isNotary);
  }, [clients, roomId, selected, isNotary]);

  return {
    title,
    filteredCards,
    selected,
    handleCall,
    setSelected,
  };
};
