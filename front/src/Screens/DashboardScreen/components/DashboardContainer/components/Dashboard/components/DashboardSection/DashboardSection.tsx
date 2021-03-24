import * as React from 'react';
import './index.scss';
import { ManagerAppointment, ManagerAppointmentCard } from '../../../../../../../../types';
import { DashboardViewType } from '../../useDashboard';

type Props = {
  sectionData: ManagerAppointment,
  onCardClick: () => void
  style: DashboardViewType;
}

const DashboardSection = ({ sectionData, onCardClick, style }: Props) => (
  <div className="dashboard__space-section">
    <h2>{`${sectionData.day} ${sectionData.date}`}</h2>
    <div className={`cards ${style === DashboardViewType.TABLE ? 'table' : ''}`}>
      {sectionData.cards.map((card: ManagerAppointmentCard) => (
        <div className="card" onClick={onCardClick}>
          <div className="card__header" style={{ backgroundColor: card.color }}>
            <span>{card.title}</span>
          </div>
          <div className="card__main">
            {card.instructions.map((item: string) => (
              <span>{item}</span>
            ))}
          </div>
        </div>
      ))}
    </div>
  </div>
);

export default DashboardSection;
