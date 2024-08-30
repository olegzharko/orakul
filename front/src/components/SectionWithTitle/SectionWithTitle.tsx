import React from 'react';
import './index.scss';

type Props = {
  title: string;
  children: React.ReactNode;
  headerColor?: string;
  onClear?: () => void;
  clientColor?: string;
}

const SectionWithTitle = ({ title, children, onClear, headerColor }: Props) => (
  <div className="section-with-title">
    <div
      className="section-with-title__header"
      style={{
        backgroundColor: headerColor || '',
      }}
    >
      <h2
        className="section-title"
        style={{
          color: headerColor ? 'white' : '',
        }}
      >
        {title}
      </h2>
      {onClear && (
        <button type="button" className="clear-button">
          <img
            src="/images/clear-form.svg"
            alt="close"
            className="clear-icon"
            onClick={onClear}
          />
        </button>
      )}
    </div>
    <div className="section-with-title__body">
      {children}
    </div>
  </div>
);

export default SectionWithTitle;
