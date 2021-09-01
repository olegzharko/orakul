import React from 'react';

type WaitingRoomCardContentProps = {
  title: string;
  icon: string;
  info: string[];
}

const WaitingRoomCardContent = ({ title, icon, info }: WaitingRoomCardContentProps) => (
  <div className="room-card__content">
    <div className="title">
      <img src={icon} alt={title} />
      {title}
    </div>
    <div className="info">
      {info.map((text) => (
        <span key={text}>{text}</span>
      ))}
    </div>
  </div>
);

export default WaitingRoomCardContent;
