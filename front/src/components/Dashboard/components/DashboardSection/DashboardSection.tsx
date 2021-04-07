import * as React from 'react';
import Card from '../../../Card';
import { DashboardViewType } from '../../useDashboard';

export type SectionCard = {
  id: number;
  title: string;
  content: string[];
  color?: string;
}

type Props = {
  link: string;
  title: string,
  cards: SectionCard[],
  style: DashboardViewType;
  haveStatus?: boolean;
}

const DashboardSection = ({ link, title, cards, style, haveStatus }: Props) => (
  <div className="dashboard__main-section">
    <h2>{title}</h2>
    <div className={`cards ${style === DashboardViewType.TABLE ? 'table' : ''}`}>
      {cards.map((card: SectionCard) => (
        <Card
          haveStatus={haveStatus}
          key={card.id}
          title={card.title}
          headerColor={card.color}
          link={`/${link}/${card.id}`}
        >
          {card.content.map((item: string) => (
            <span key={item} className="card__content-item">{item}</span>
          ))}
        </Card>
      ))}
    </div>
  </div>
);

export default DashboardSection;
