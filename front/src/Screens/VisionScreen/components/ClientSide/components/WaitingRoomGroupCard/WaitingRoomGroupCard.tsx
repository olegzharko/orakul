import React from 'react';

type WaitingRoomGroupCardProps = {
  title: string;
  headerButtonTitle: string;
  onHeaderButtonClick: () => void;
}

const WaitingRoomGroupCard = (
  { headerButtonTitle, title, onHeaderButtonClick }: WaitingRoomGroupCardProps
) => (
  <div className="room-card-group">
    <div className="room-card-group__header">
      <span className="room-card-group__header-title">{title}</span>
      <button type="button" className="room-card-group__header-button">{headerButtonTitle}</button>
    </div>
    <div className="room-card-group__body">
      <div className="room-card-group__person">
        <div className="colour-mark" style={{ backgroundColor: 'green' }} />
        <div className="content-group">
          <span className="time">13:00</span>
          <span className="company">КАН (Петров В.О.)</span>
          <span className="person">Жарко Олег Володимирович</span>
        </div>
      </div>

      <div className="room-card-group__person">
        <div className="colour-mark" style={{ backgroundColor: 'blue' }} />
        <div className="content-group">
          <span className="time">13:00</span>
          <span className="company">КАН (Петров В.О.)</span>
          <span className="person">Жарко Олег Володимирович</span>
        </div>
      </div>

      <div className="room-card-group__person">
        <div className="colour-mark" style={{ backgroundColor: 'grey' }} />
        <div className="content-group">
          <span className="time">13:00</span>
          <span className="company">КАН (Петров В.О.)</span>
          <span className="person">Жарко Олег Володимирович</span>
        </div>
      </div>
    </div>
  </div>
);

export default WaitingRoomGroupCard;
