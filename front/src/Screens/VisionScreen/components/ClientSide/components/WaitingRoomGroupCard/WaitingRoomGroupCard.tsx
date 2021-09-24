import React from 'react';

import { useWaitingRoomGroupCard, WaitingRoomGroupCardProps } from './useWaitingRoomGroupCard';

const WaitingRoomGroupCard = (props: WaitingRoomGroupCardProps) => {
  const {
    title,
    filteredCards,
    selected,
    handleCall,
    setSelected,
  } = useWaitingRoomGroupCard(props);

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
