import React from 'react';
import { ArchiveToolsNotaryFormatted } from '../../types';

type ArchiveTabBarProps = {
  notaries: ArchiveToolsNotaryFormatted[];
  selectedNotary: number;
}

const ArchiveTabBar = ({ notaries, selectedNotary }: ArchiveTabBarProps) => (
  <div className="vision-archive__tabs">
    {notaries.map(({ id, title, onClick }) => (
      <div
        key={id}
        className={`tab ${id === selectedNotary ? 'selected' : ''}`}
        onClick={onClick}
        style={{ width: `${100 / notaries.length}%` }}
      >
        {title}
      </div>
    ))}
  </div>
);

export default ArchiveTabBar;
