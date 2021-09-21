import React, { useCallback, useState } from 'react';

type WaitingRoomGroupCardProps = {
  title: string;
  roomId: number;
  clients: {
    id: number;
    time: string,
    developer: string,
    name: string,
    onCall: (roomId: number) => void;
  }[];
}

const WaitingRoomGroupCard = (
  { title, clients, roomId }: WaitingRoomGroupCardProps
) => {
  const [selected, setSelected] = useState<number | undefined>();

  const handleCall = useCallback(() => {
    const selectedClient = clients.find(({ id }) => id === selected);
    if (!selectedClient) throw new Error(`Can't find client with id: ${selected}`);

    selectedClient.onCall(roomId);
  }, [clients, roomId, selected]);

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
        {clients.map((client) => (
          <div
            className={`room-card-group__person ${selected === client.id ? 'selected' : ''}`}
            onClick={() => setSelected(client.id)}
          >
            <div className="colour-mark" style={{ backgroundColor: 'green' }} />
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
