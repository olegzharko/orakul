import { useMemo, useState } from 'react';
import { SectionCard } from './components/DashboardSection/DashboardSection';

// eslint-disable-next-line no-shadow
export enum DashboardViewType {
  CARDS,
  TABLE
}

export type Section = {
  title: string;
  cards: SectionCard[];
}

export type Props = {
  link: string,
  sections: Section[],
  isChangeTypeButton?: boolean,
  style?: DashboardViewType,
  haveStatus?: boolean;
}

export const useDashboard = ({ style }: Props) => {
  const [selectedType, setSelectedType] = useState(style || DashboardViewType.CARDS);

  return { selectedType, setSelectedType };
};
