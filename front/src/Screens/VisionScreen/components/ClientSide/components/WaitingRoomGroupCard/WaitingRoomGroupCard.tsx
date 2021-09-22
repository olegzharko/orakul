import React, { useCallback, useMemo, useState } from 'react';

import { WaitingRoomGroupCardClient } from '../../types';

type WaitingRoomGroupCardProps = {
  title: string;
  roomId: number;
  clients: WaitingRoomGroupCardClient[];
  isNotary?: boolean;
  notary_id?: number;
}

const WaitingRoomGroupCard = (
  { title, clients, roomId, isNotary, notary_id }: WaitingRoomGroupCardProps
) => {
  const [selected, setSelected] = useState<number | undefined>();

  const handleCall = useCallback(() => {
    const selectedClient = clients.find(({ id }) => id === selected);
    if (!selectedClient) throw new Error(`Can't find client with id: ${selected}`);

    selectedClient.onCall(roomId, isNotary);
  }, [clients, roomId, selected, isNotary]);

  const filteredCards = useMemo(() => {
    if (isNotary) {
      return clients.filter((client) => client.notary_id === notary_id);
    }

    return clients;
  }, [notary_id, clients, isNotary]);

  return (
    <div className="room-card-group">
      <div className="room-card-group__header">
        <span className="room-card-group__header-title">{title}</span>
        <button
          type="button"
          className="room-card-group__header-button"
          onClick={handleCall}
        >
          Запросити
        </button>
      </div>
      <div className="room-card-group__body">
        {filteredCards.map((client) => (
          <div
            className={`room-card-group__person ${selected === client.id ? 'selected' : ''}`}
            onClick={() => setSelected(client.id)}
          >
            <div className="colour-mark" style={{ backgroundColor: client.color }} />
            <div className="content-group">
              <span className="time">{client.time}</span>
              <span className="company">{client.developer}</span>
              <span className="person">{client.name}</span>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default WaitingRoomGroupCard;
