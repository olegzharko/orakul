import React from 'react';

type ArchiveTabBarProps = {
  tabs: string[];
  selectedIndex: number;
  onClick: (index: number) => void;
}

const ArchiveTabBar = ({ tabs, selectedIndex, onClick }: ArchiveTabBarProps) => (
  <div className="vision-archive__tabs">
    {tabs.map((title, index) => (
      <div
        key={title}
        className={`tab ${index === selectedIndex ? 'selected' : ''}`}
        onClick={() => onClick(index)}
        style={{ width: `${100 / tabs.length}%` }}
      >
        {title}
      </div>
    ))}
  </div>
);

export default ArchiveTabBar;
